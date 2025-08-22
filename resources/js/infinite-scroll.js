class InfiniteScroll {
    constructor(container, options = {}) {
        this.container = typeof container === 'string' ? document.querySelector(container) : container
        this.options = {
            path: options.path || '',
            append: options.append || '.append-here',
            prefill: options.prefill !== false,
            loadOnInit: options.loadOnInit !== false,
            button: options.button || '.load-more',
            ...options
        }

        this.loading = false
        this.hasNext = true
        this.nextPage = 1

        this.init()
    }

    init() {
        if (this.options.loadOnInit && this.options.prefill) {
            this.loadNext()
        }

        if (this.options.button) {
            const button = typeof this.options.button === 'string'
                ? document.querySelector(this.options.button)
                : this.options.button

            if (button) {
                button.addEventListener('click', () => this.loadNext())
            }
        }

        this.setupScrollListener()
    }

    setupScrollListener() {
        window.addEventListener('scroll', () => {
            if (this.shouldLoad()) {
                this.loadNext()
            }
        })
    }

    shouldLoad() {
        if (this.loading || !this.hasNext) return false

        const scrollTop = window.scrollY || document.documentElement.scrollTop
        const scrollHeight = document.documentElement.scrollHeight
        const clientHeight = document.documentElement.clientHeight

        return scrollTop + clientHeight >= scrollHeight - 300
    }

    async loadNext() {
        if (this.loading || !this.hasNext) return

        this.loading = true
        this.showLoading()

        try {
            const url = this.buildUrl()
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`)
            }

            const data = await response.json()
            this.processResponse(data)

        } catch (error) {
            console.error('InfiniteScroll error:', error)
            this.hasNext = false
            this.showError()
        } finally {
            this.loading = false
            this.hideLoading()
        }
    }

    buildUrl() {
        let url = this.options.path
        const hasQuery = url.includes('?')

        url += `${hasQuery ? '&' : '?'}page=${this.nextPage}`

        return url
    }

    processResponse(data) {
        if (data.html) {
            this.appendContent(data.html)
            this.nextPage++

            if (data.next_page === null || data.next_page === undefined) {
                this.hasNext = false
                this.hideButton()
            }
        } else {
            this.hasNext = false
            this.hideButton()
        }
    }

    appendContent(html) {
        const appendElement = this.options.append
            ? this.container.querySelector(this.options.append)
            : this.container

        if (appendElement) {
            appendElement.insertAdjacentHTML('beforeend', html)
        } else {
            this.container.insertAdjacentHTML('beforeend', html)
        }

        // Dispatch event
        this.container.dispatchEvent(new CustomEvent('infinite-scroll:appended', {
            detail: { html }
        }))
    }

    showLoading() {
        this.container.dispatchEvent(new CustomEvent('infinite-scroll:loading-start'))

        const loadingEl = document.createElement('div')
        loadingEl.className = 'infinite-scroll-loading'
        loadingEl.innerHTML = `
            <div class="flex justify-center py-4">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
            </div>
        `

        this.container.appendChild(loadingEl)
    }

    hideLoading() {
        this.container.dispatchEvent(new CustomEvent('infinite-scroll:loading-end'))

        const loadingEl = this.container.querySelector('.infinite-scroll-loading')
        if (loadingEl) {
            loadingEl.remove()
        }
    }

    showError() {
        const errorEl = document.createElement('div')
        errorEl.className = 'infinite-scroll-error text-center py-4 text-red-600'
        errorEl.textContent = 'Failed to load more content.'

        this.container.appendChild(errorEl)
    }

    hideButton() {
        if (this.options.button) {
            const button = typeof this.options.button === 'string'
                ? document.querySelector(this.options.button)
                : this.options.button

            if (button) {
                button.style.display = 'none'
            }
        }
    }

    destroy() {
        window.removeEventListener('scroll', this.scrollListener)
        this.loading = false
        this.hasNext = false
    }
}

// Auto-initialize elements with data-infinite-scroll
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-infinite-scroll]').forEach(container => {
        const options = {
            path: container.dataset.path,
            append: container.dataset.append,
            button: container.dataset.button ? container.dataset.button : null,
            loadOnInit: container.dataset.loadOnInit !== 'false',
            prefill: container.dataset.prefill !== 'false'
        }

        new InfiniteScroll(container, options)
    })
})

// Export for global access
window.InfiniteScroll = InfiniteScroll
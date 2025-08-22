import Alpine from 'alpinejs'

window.Alpine = Alpine

// Dark mode store
Alpine.store('darkMode', {
    on: localStorage.getItem('darkMode') === 'true',

    toggle() {
        this.on = !this.on
        localStorage.setItem('darkMode', this.on)
        this.updateHtmlClass()
    },

    init() {
        this.updateHtmlClass()
        window.addEventListener('dark-mode-toggled', (e) => {
            this.on = e.detail
            this.updateHtmlClass()
        })
    },

    updateHtmlClass() {
        if (this.on) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    }
})

// Notifications store
Alpine.store('notifications', {
    items: [],
    unreadCount: 0,

    init() {
        this.loadNotifications()
        this.setupEcho()
    },

    async loadNotifications() {
        try {
            const response = await fetch('/api/notifications')
            const data = await response.json()
            this.items = data.notifications
            this.unreadCount = data.unread_count
        } catch (error) {
            console.error('Error loading notifications:', error)
        }
    },

    setupEcho() {
        if (typeof Echo !== 'undefined') {
            Echo.private(`App.Models.User.${window.userId}`)
                .notification((notification) => {
                    this.items.unshift(notification)
                    this.unreadCount++

                    // Show toast notification
                    this.showToast(notification)
                })
        }
    },

    showToast(notification) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })

        Toast.fire({
            icon: 'info',
            title: notification.data.message
        })
    },

    markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        }).then(() => {
            const notification = this.items.find(n => n.id === notificationId)
            if (notification) {
                notification.read_at = new Date().toISOString()
                this.unreadCount = Math.max(0, this.unreadCount - 1)
            }
        })
    },

    markAllAsRead() {
        fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        }).then(() => {
            this.items.forEach(notification => {
                notification.read_at = new Date().toISOString()
            })
            this.unreadCount = 0
        })
    }
})

// Infinite scroll component
Alpine.data('infiniteScroll', (url) => ({
    items: [],
    nextPage: 1,
    loading: false,
    hasMore: true,

    init() {
        this.loadItems()

        window.addEventListener('scroll', () => {
            if (this.shouldLoadMore()) {
                this.loadItems()
            }
        })
    },

    shouldLoadMore() {
        return !this.loading && this.hasMore &&
            window.innerHeight + window.scrollY >= document.body.offsetHeight - 500
    },

    async loadItems() {
        if (this.loading || !this.hasMore) return

        this.loading = true

        try {
            const response = await fetch(`${url}?page=${this.nextPage}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })

            const data = await response.json()

            if (data.html) {
                this.items.push(...data.items || [])
                this.nextPage++
                this.hasMore = data.has_more !== false

                // If we have HTML content, append it
                if (data.html) {
                    this.$el.insertAdjacentHTML('beforeend', data.html)
                }
            } else {
                this.hasMore = false
            }
        } catch (error) {
            console.error('Error loading items:', error)
            this.hasMore = false
        } finally {
            this.loading = false
        }
    }
}))

// Modal component
Alpine.data('modal', (initialOpen = false) => ({
    open: initialOpen,

    init() {
        if (this.open) {
            this.show()
        }
    },

    show() {
        this.open = true
        document.body.style.overflow = 'hidden'
    },

    hide() {
        this.open = false
        document.body.style.overflow = 'auto'
    },

    toggle() {
        this.open ? this.hide() : this.show()
    }
}))

// Dropdown component
Alpine.data('dropdown', (initialOpen = false) => ({
    open: initialOpen,

    toggle() {
        this.open = !this.open
    },

    close() {
        this.open = false
    }
}))

Alpine.start()
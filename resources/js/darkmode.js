class DarkMode {
    static init() {
        this.loadPreference()
        this.setupEventListeners()
    }

    static loadPreference() {
        const saved = localStorage.getItem('darkMode')
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches

        const isDark = saved === 'true' || (saved === null && prefersDark)

        if (isDark) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        return isDark
    }

    static setupEventListeners() {
        // Listen for system preference changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (localStorage.getItem('darkMode') === null) {
                if (e.matches) {
                    document.documentElement.classList.add('dark')
                } else {
                    document.documentElement.classList.remove('dark')
                }
            }
        })

        // Dispatch event for Alpine.js components
        document.addEventListener('alpine:init', () => {
            Alpine.store('darkMode', {
                on: this.loadPreference(),

                toggle() {
                    this.on = !this.on
                    localStorage.setItem('darkMode', this.on)

                    if (this.on) {
                        document.documentElement.classList.add('dark')
                    } else {
                        document.documentElement.classList.remove('dark')
                    }

                    // Dispatch custom event
                    document.dispatchEvent(new CustomEvent('dark-mode-toggled', {
                        detail: this.on
                    }))
                }
            })
        })
    }

    static toggle() {
        const isDark = document.documentElement.classList.contains('dark')

        if (isDark) {
            document.documentElement.classList.remove('dark')
            localStorage.setItem('darkMode', 'false')
        } else {
            document.documentElement.classList.add('dark')
            localStorage.setItem('darkMode', 'true')
        }

        // Dispatch event
        document.dispatchEvent(new CustomEvent('dark-mode-toggled', {
            detail: !isDark
        }))

        return !isDark
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    DarkMode.init()
})

// Export for global access
window.DarkMode = DarkMode
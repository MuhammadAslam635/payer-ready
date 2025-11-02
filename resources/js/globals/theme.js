/**
* Sheaf Dark Mode Theme System
* Provides comprehensive theme management with Alpine.js integration
*/

import defineReactiveMagicProperty from '../utils.js';

document.addEventListener('alpine:init', () => {
    // Only initialize if Alpine is available and not already initialized
    if (typeof Alpine !== 'undefined' && !window.themeInitialized) {
        window.themeInitialized = true;
        defineReactiveMagicProperty('theme', {
        currentTheme: null,
        storedTheme: null,

        init() {
            // Dark mode disabled - always use light theme
            this.storedTheme = 'light';
            this.currentTheme = 'light';

            // Ensure dark class is removed from DOM
            applyTheme('light');

            // Clear any dark mode preference from localStorage
            localStorage.removeItem('theme');
        },

        /**
            * Set theme preference and persist to localStorage
            * Dark mode disabled - always force light theme
            */
        setTheme(newTheme) {
            // Force light theme always
            this.storedTheme = 'light';
            this.currentTheme = 'light';
            localStorage.setItem('theme', 'light');
            applyTheme('light');
        },

        /**
            * Theme setter methods - Dark mode disabled, always use light
            */
        setLight() {
            this.setTheme('light');
        },

        setDark() {
            // Dark mode disabled - force light
            this.setTheme('light');
        },

        setSystem() {
            // Dark mode disabled - force light
            this.setTheme('light');
        },

        /**
            * Toggle between light and dark themes - Dark mode disabled, always light
            */
        toggle() {
            // Dark mode disabled - always stay on light
            this.setTheme('light');
        },

        /**
            * Get current theme state information
            */
        get() {
            return {
                stored: this.storedTheme,
                current: this.currentTheme,
                isLight: this.isLight,
                isDark: this.isDark,
                isSystem: this.isSystem
            };
        },

        // Getter methods for easy template usage - Dark mode disabled
        get isLight() {
            return true; // Always light
        },

        get isDark() {
            return false; // Dark mode disabled
        },

        get isSystem() {
            return false; // System mode disabled
        },

        /**
            * Sometimes we need to show only light or dark, not system mode.
            * These getters handle scenarios where we need the resolved theme state.
            * Dark mode disabled - always return light
            */
        get isResolvedToLight() {
            return true; // Always light
        },

        get isResolvedToDark() {
            return false; // Dark mode disabled
        }
    });
    }
});

/**
    * Static helper functions
    */

function computeTheme(themePreference) {
    if (themePreference === 'system') {
        return getSystemTheme();
    }
    return themePreference;
}

function getSystemTheme() {
    return window.matchMedia('(prefers-color-scheme: dark)').matches
        ? 'dark'
        : 'light';
}

function applyTheme(theme) {
    const documentElement = document.documentElement;

    if (theme === 'dark') {
        documentElement.classList.add('dark');
    } else {
        documentElement.classList.remove('dark');
    }

    // Dispatch custom event for theme change listeners
    document.dispatchEvent(new CustomEvent('theme-changed', {
        detail: { theme }
    }));
}

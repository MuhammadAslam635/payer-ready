/**
* Sheaf Utility Functions
* Provides reactive magic property registration for Alpine.js
*/

export default function defineReactiveMagicProperty(name, rawObject) {
    // Check if Alpine is available and not already defined
    if (typeof Alpine === 'undefined') {
        console.warn('Alpine.js is not available');
        return;
    }

    const instance = Alpine.reactive(rawObject);

    /**
        * Reactive objects are plain proxies and do not support hooks like stores,
        * or scopes in Alpine.js so we initialize manually
        */
    if (typeof instance.init === 'function') {
        instance.init();
    }

    // Check if magic property already exists
    if (!Alpine.magic(name)) {
        Alpine.magic(name, () => instance);
    }

    // Register the magic property globally
    // Ex: if the magic is called \$theme, we register Theme into the window
    window[name[0].toUpperCase() + name.slice(1)] = instance;
}

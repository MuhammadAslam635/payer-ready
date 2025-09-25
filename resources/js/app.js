import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Import theme before registering plugins
import './globals/theme.js'; /* By Sheaf.dev */
import './globals/modals.js';
// now you can register
// components using Alpine.data(...) and
// plugins using Alpine.plugin(...)

Livewire.start()

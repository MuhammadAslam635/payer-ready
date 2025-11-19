<?php if (isset($component)) { $__componentOriginal0c01f5d27989ff8806888d77a08be8a4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0c01f5d27989ff8806888d77a08be8a4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.options.button','data' => ['xData' => '{
        revealed: false,
        toggleReveal() {
            const input = this.$refs.input;
            if (!input) return;
            
            this.revealed = !this.revealed;
            input.type = this.revealed ? \'text\' : \'password\';
        }
    }','xOn:click' => 'toggleReveal()','xBind:dataSlotRevealed' => 'revealed','xBind:ariaLabel' => 'revealed ? \'Hide password\' : \'Show password\'','xBind:title' => 'revealed ? \'Hide password\' : \'Show password\'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input.options.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-data' => '{
        revealed: false,
        toggleReveal() {
            const input = this.$refs.input;
            if (!input) return;
            
            this.revealed = !this.revealed;
            input.type = this.revealed ? \'text\' : \'password\';
        }
    }','x-on:click' => 'toggleReveal()','x-bind:data-slot-revealed' => 'revealed','x-bind:aria-label' => 'revealed ? \'Hide password\' : \'Show password\'','x-bind:title' => 'revealed ? \'Hide password\' : \'Show password\'']); ?>     
    <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'eye-slash','class' => 'hidden [[data-slot-revealed]>&]:block','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'eye-slash','class' => 'hidden [[data-slot-revealed]>&]:block','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $attributes = $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $component = $__componentOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'eye','class' => 'block [[data-slot-revealed]>&]:hidden','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'eye','class' => 'block [[data-slot-revealed]>&]:hidden','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $attributes = $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $component = $__componentOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0c01f5d27989ff8806888d77a08be8a4)): ?>
<?php $attributes = $__attributesOriginal0c01f5d27989ff8806888d77a08be8a4; ?>
<?php unset($__attributesOriginal0c01f5d27989ff8806888d77a08be8a4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0c01f5d27989ff8806888d77a08be8a4)): ?>
<?php $component = $__componentOriginal0c01f5d27989ff8806888d77a08be8a4; ?>
<?php unset($__componentOriginal0c01f5d27989ff8806888d77a08be8a4); ?>
<?php endif; ?><?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/components/ui/input/options/revealable.blade.php ENDPATH**/ ?>
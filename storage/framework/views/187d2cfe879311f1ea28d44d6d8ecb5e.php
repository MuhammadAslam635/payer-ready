<?php foreach (([
    'icon' => '',
    'iconAfter' => 'chevron-up-down',
    'disabled' => false,
    'clearable' => false,
    'triggerClass' => '',
    'invalid' => false,
    'trigger' => null,
]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>
<div
    x-ref="selectTrigger"
    data-slot="trigger"
    role="combobox"
    <?php echo e($attributes->class([
        'relative grid place-items-center grid-cols-[40px_1fr_26px_35px]',
        // when there is a left icon, give the select-control button padding-left so text doesn't overlap
        '[&>[data-slot=icon]+[data-slot=select-control]]:pl-10',
        // when there is only one icon (iconAfter), give button padding-right for single icon
        '[&:has([data-slot=select-control]+[data-slot=icon])>[data-slot=select-control]]:pr-7',
        // when there are two icons (iconAfter + clearable), give button more padding-right
        '[&:has([data-slot=select-control]+[data-slot=icon]+[data-slot=select-clear])>[data-slot=select-control]]:pr-14',
        // disable left icon opacity and cursor if component is disabled
        '[&_[data-slot=icon]]:opacity-40 [&_[data-slot=icon]]:cursor-auto' => $disabled,
    ])); ?>

>
    <!--[if BLOCK]><![endif]--><?php if(filled($icon)): ?>
        <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => $icon,'class' => 'col-span-1 col-start-1 row-start-1 h-full w-full text-black flex items-center justify-center z-10 !size-[1.10rem]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => 'col-span-1 col-start-1 row-start-1 h-full w-full text-black flex items-center justify-center z-10 !size-[1.10rem]']); ?>
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
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <button
        x-on:click="toggle"
        x-bind:aria-expanded="open"
        type="button"
        aria-haspopup="listbox"
        data-slot="select-control"
        <?php if($disabled): echo 'disabled'; endif; ?>
        <?php echo e($attributes->class([
            'border bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 truncate border-black/10 dark:bg-neutral-900 dark:border-white/10 border-gray-300 dark:text-gray-300 rounded-lg px-2 py-2 text-start ',
            'col-span-4 col-start-1 row-start-1 justify-self-stretch',
                // make button span all available grid columns
            'disabled:opacity-60 flex disabled:cursor-auto cursor-pointer',
            'overflow-hidden whitespace-nowrap',
            'border-red-500/50!' => $invalid,
            $triggerClass,
        ])); ?>

    >
        <span class="truncate block w-full">
            <span x-text="label">select...</span>
        </span>
    </button>

    <!--[if BLOCK]><![endif]--><?php if(filled($iconAfter)): ?>
        <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => $iconAfter,'class' => 'col-span-1 row-start-1 [&:has(+[data-slot=select-clear])]:col-start-3 [&:not(:has(+[data-slot=select-clear]))]:col-start-4 !size-[1.15rem]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconAfter),'class' => 'col-span-1 row-start-1 [&:has(+[data-slot=select-clear])]:col-start-3 [&:not(:has(+[data-slot=select-clear]))]:col-start-4 !size-[1.15rem]']); ?>
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
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if($clearable): ?>
        <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'trash','dataSlot' => 'select-clear','xOn:click' => 'clear','class' => 'col-span-1 row-start-1 !size-[1.15rem] col-start-4 cursor-pointer','xBind:class' => '!hasSelection && \'opacity-50\'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'trash','data-slot' => 'select-clear','x-on:click' => 'clear','class' => 'col-span-1 row-start-1 !size-[1.15rem] col-start-4 cursor-pointer','x-bind:class' => '!hasSelection && \'opacity-50\'']); ?>
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
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH E:\payer-ready\resources\views/components/ui/select/trigger.blade.php ENDPATH**/ ?>
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl">Superadmin — Usuarios</h2>
            <a href="<?php echo e(route('super.users.create')); ?>" class="btn btn-primary">+ Nuevo</a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="p-6">
        <form class="mb-4">
            <input type="text" name="s" value="<?php echo e(request('s')); ?>" placeholder="Buscar…" class="input">
            <button class="btn">Buscar</button>
        </form>

        <div class="rounded-2xl border p-4 bg-white dark:bg-slate-900">
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between py-2 border-b last:border-0">
                    <div>
                        <div class="font-medium"><?php echo e($u->name); ?></div>
                        <div class="text-sm text-slate-500"><?php echo e($u->email); ?></div>
                    </div>
                    <div class="text-xs">
                        <?php if($u->is_superadmin): ?> <span class="px-2 py-1 rounded bg-purple-100 text-purple-700">Superadmin</span> <?php endif; ?>
                        <?php if($u->is_admin): ?> <span class="px-2 py-1 rounded bg-indigo-100 text-indigo-700">Admin</span> <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div>No hay usuarios.</div>
            <?php endif; ?>
        </div>

        <div class="mt-4"><?php echo e($users->links()); ?></div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\dev\inmobiliaria\resources\views/super/users/index.blade.php ENDPATH**/ ?>
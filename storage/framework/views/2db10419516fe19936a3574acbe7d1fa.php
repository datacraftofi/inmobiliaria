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
    <?php echo $__env->make('admin.partials.topnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
   <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="rounded-2xl p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="text-sm text-slate-500">Solicitudes totales</div>
                    <div class="mt-1 text-3xl font-semibold"><?php echo e($totalSolicitudes); ?></div>
                </div>
                <div class="rounded-2xl p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="text-sm text-slate-500">Hoy</div>
                    <div class="mt-1 text-3xl font-semibold"><?php echo e($solicitudesHoy); ?></div>
                </div>
                <div class="rounded-2xl p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="text-sm text-slate-500">Enviadas</div>
                    <div class="mt-1 text-3xl font-semibold"><?php echo e($enviadas); ?></div>
                </div>
                <div class="rounded-2xl p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="text-sm text-slate-500">Borradores</div>
                    <div class="mt-1 text-3xl font-semibold"><?php echo e($borradores); ?></div>
                </div>
                <div class="rounded-2xl p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="text-sm text-slate-500">Soportes</div>
                    <div class="mt-1 text-3xl font-semibold"><?php echo e($totalSoportes); ?></div>
                </div>
                <div class="rounded-2xl p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="text-sm text-slate-500">Referencias</div>
                    <div class="mt-1 text-3xl font-semibold"><?php echo e($totalReferencias); ?></div>
                </div>
            </div>

            
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="font-semibold">Últimas solicitudes</h3>
                </div>
                <div class="divide-y divide-slate-200 dark:divide-slate-800">
                    <?php $__empty_1 = true; $__currentLoopData = $ultimas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="px-5 py-3 flex items-center justify-between">
                            <div class="min-w-0">
                                <div class="text-sm font-medium truncate"><?php echo e($s->nombre ?? '—'); ?></div>
                                <div class="text-xs text-slate-500 font-mono truncate"><?php echo e($s->id); ?></div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-xs px-2 py-1 rounded-full
                                    <?php echo e($s->estado === 'enviada' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300'); ?>">
                                    <?php echo e($s->estado); ?>

                                </span>
                                <span class="text-xs text-slate-500"><?php echo e($s->created_at->diffForHumans()); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-5 py-6 text-sm text-slate-500">Aún no hay solicitudes.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
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
<?php /**PATH C:\dev\inmobiliaria\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
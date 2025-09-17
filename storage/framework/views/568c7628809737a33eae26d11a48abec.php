<div class="flex items-center justify-between">
  <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
    Panel de Administración
  </h2>

  <div class="flex gap-2">
    <a href="<?php echo e(route('admin.dashboard')); ?>"
       class="inline-flex items-center rounded-lg px-3 py-1.5 text-sm
              <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100'); ?>">
      Resumen
    </a>

    <a href="<?php echo e(route('admin.solicitudes.index')); ?>"
       class="inline-flex items-center rounded-lg px-3 py-1.5 text-sm
              <?php echo e(request()->routeIs('admin.solicitudes.*') ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100'); ?>">
      Solicitudes
    </a>
  </div>
</div>
<?php /**PATH C:\dev\inmobiliaria\resources\views/admin/partials/topnav.blade.php ENDPATH**/ ?>
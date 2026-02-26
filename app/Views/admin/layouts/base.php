<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= meta_title($title ?? 'Dashboard') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?= $this->include('admin/components/sidebar') ?>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <?= $this->include('admin/components/topbar') ?>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4">
                <!-- Alert Messages -->
                <?= $this->include('admin/components/alerts') ?>
                
                <!-- Content -->
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>
    
</body>
</html>
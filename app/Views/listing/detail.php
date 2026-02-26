<form method="post" action="/listing/create" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <label>Category</label><br>
    <select name="category_id" required>
        <?php foreach($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Title</label><br>
    <input type="text" name="title" required><br><br>

    <label>Description</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Price</label><br>
    <input type="number" name="price"><br><br>

    <label>Location</label><br>
    <input type="text" name="location"><br><br>

    <label>Featured Image</label><br>
    <input type="file" name="featured_image"><br><br>

    <button type="submit">Save Listing</button>
</form>
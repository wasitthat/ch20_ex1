<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>
<section>
    <h1>Category Manager - Category List</h1>
    <table id="category_table">
        <form action="." method="post">
            <tr>
                <th>Name</th>

            </tr>

            <?php foreach ($categories as $category) : ?>
                <tr>
                    <td>
                        <?php echo $category->getName(); ?>
                    </td>
                    <td>
                        <form action="." method="post">
                            <input type="hidden" name="action" value="delete_category">
                            <input type="hidden" name="category_id" value="<?php echo $category->getID(); ?>" ;>
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </form>
    </table>

    <h2>Add Category</h2>
    <form action="index.php" method="post" id="add_category_form">
        <input type="hidden" name="action" value='add_category'>
        <input type="text" name="categoryName">
        <input type="submit" value="Add">
    </form>
</section>
<?php include '../../view/footer.php'; ?>
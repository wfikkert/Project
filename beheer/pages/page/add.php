<?php

minRole(3);
?>
<script type="text/javascript" src="javascript/slug.js"></script>
<script type="text/javascript" src="/Project/beheer/res/javascript/wysiwyg-editor.js"></script>

<a href="/beheer/page" class="button">Terug naar overzicht</a>
<h1>Nieuwe pagina</h1>
<form action="" method="post">
    <label>Titel</label>
    <input type="text" name="titel" onkeyup="updateValue()" id="title" value="<?php echo set_value("title"); ?>">
    <label>Onderschrift</label>
    <input type="text" name="description" value="<?php echo set_value("description"); ?>">
    <label>Doelmap</label>
    <input type="text" name="slug" value="<?php echo set_value("slug"); ?>" id="slug">
    <label>Tekst</label>
    <textarea rows="4" cols="50" name="body" ><?php echo set_value("body"); ?></textarea>
    <label>publiceren</label>
    <input type="checkbox" name="publish" value="1">
    <label id="in_nav-text">in navigatie?</label>
    <input id="in_nav-checkbox" type="checkbox" name="in_nav-checkbox" value="0" onchange="showIn_nav()">
    <input id="in_nav-number" type="number" name="in_nav-number" value="<?php echo set_value("in_nav-number",0); ?>">
    <br>
    <input type="submit" name="submit" value="versturen">
</form>

<?php
if (isset($_POST["submit"])) {
    if (!empty($_POST["titel"])) {
        if (!empty($_POST["body"])) {
            if (!(empty($_POST['slug']) || $mysqli->query("SELECT * FROM page WHERE slug = '$slug'")->num_rows > 0)) {
                $titel = post('titel');
                $description = post('description');
                $body = post('body');
                $slug = urlencode(strtolower(post('slug')));
                if (post('publish') == 1) {
                    $published = 1;
                } else {
                    $published = 0;
                }
                if (post('in_nav-checkbox') == 1) {
                    $in_nav = post('in_nav-number');
                } else {
                    $in_nav = 0;
                }

                $query = "SELECT * FROM page WHERE slug = \"$slug\"";
                $result = $mysqli->query($query);
                if ($mysqli->query($query)->num_rows == 0) {
                    if ($mysqli->query("SELECT COUNT(*) FROM page WHERE title = '$titel' AND description = '$description' AND body = '$body' AND slug = '$slug' ") > 0) {
                        redirect('/beheer/page');
                    }
                    $query = "INSERT INTO page (title, slug, published, in_nav, description, body) VALUES (\"$titel\",\"$slug\", \"$published\", \"$in_nav\", \"$description\", \"$body\")";
                    if (!$mysqli->query($query)) {
                        echo $mysqli->error;
                    } else {
                        redirect('/beheer/page');
                    }
                }
            } else {
                echo "Deze doelmap bestaat al.";
            }
        } else {
            echo "Vul text in.";
        }
    } else {
        echo "Vul een titel in.";
    }
}

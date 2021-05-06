<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <title>Quotes</title>
</head>
<body>
    <div id="wrapper">
        <form action="." method="GET" class="quote_option_form">
        <nav class="navbar sticky-top navbar-light" style="background-color: none">
        <a class="navbar-brand" href="."><h1>Quotes</h1></a>
            <section>
                <select class="quote_options" id="author" name="authorId">
                <option value="0">View All Authors</option>
                <?php foreach ($author as $author): ?>
                    <option value="<?= $author['id'] ?>"><?= $author['author'] ?></option>
                <?php endforeach; ?>
                </select>
                <select class="quote_options" id="category" name="categoryId">
                <option value="0">View All Categories</option>
                <?php foreach ($category as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['category'] ?></option>
                <?php endforeach; ?>
                </select>
            </section>
            <section class="button">
                <button type="submit" class="btn btn-dark">Go</button>
                <button type="reset" class="btn btn-dark">Reset</button>
            </section>
        </nav>
        </form>
        <div id="display_quotes">
            <h3>There are no quotes for this search! 
                Please try another search!</h3>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
<footer id="page">
<p>© <?php echo date("Y"); ?> Quotivation</p>
    <p>Website by Moiz</p>
</footer>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magebit Dev Task - Admin</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="js/main.js"></script>
</head>
<body onload="init();">
    <div class="container">
        <div class="row">
            <ul id="domains"></ul>
        </div>
        <table class="table" id="subscription-table">
            <thead>
                <tr>
                <th scope="col">E-Mail</th>
                <th scope="col">Creation Date</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr id="placeholder-loading"><td colspan="3"><center>Loading ...</center></td></tr>
            </tbody>
        </table>

        <nav aria-label="...">
            <ul id="pagination" class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    <style>
        #domains {
            margin: 20px;
            list-style: none;
        }
        #domains li {
            margin-right: 10px;
            display: inline;
        }
    </style>
</body>
</html>
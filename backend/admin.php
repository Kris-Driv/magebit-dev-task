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
            <ul id="domains" class="left col"></ul>
            <div class="right col">
                <input type="text" name="search" id="search">
            </div>
        </div>
        <table class="table" id="subscription-table">
            <thead>
                <tr>
                <th scope="col">E-Mail</th>
                <th scope="col"><a href="#" onclick="swapSort()">Creation Date</a> <span id="sortval"></span></th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr id="placeholder-loading"><td colspan="3"><center>Loading ...</center></td></tr>
            </tbody>
        </table>

        <div class="row">
            <div class="left col">
                <nav aria-label="...">
                    <ul id="pagination" class="pagination">
                        <p>Database is empty</p>
                    </ul>
                </nav>
            </div>
            <div class="right col">
                <button id="download" class="btn btn-success" disabled>Download</button>
            </div>
        </div>
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
        .right, .left {
            display: inline;
        }
        .right {
            float: right;
        }
        .left {
            float: left;
        }
        #download {
            float: right;
        }
        #search {
            max-width: 200px;
            width: 100%;
            margin-top: 80px;
            margin-bottom: 5px;
            float: right;
        }
    </style>
</body>
</html>
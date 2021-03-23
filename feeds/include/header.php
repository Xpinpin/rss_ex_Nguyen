<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog - <?php echo $pageTitle ?></title>
</head>

<body>
    <div id="wrapper">
        <nav>
            <a href="index.php">HOME</a> |

            <a href="allPosts.php">ALL POSTS</a> |

            <?php
            if (isset($_SESSION['authId'])) {
                echo '
                <a href="insertPost.php">INSERT</a> |
            </li>';
                echo '
                <a href="logout.php">LOGOUT</a> 
            </li>';
            } else {
                echo '
                <a href="login.php">LOGIN</a> 
            </li>';
            }

            ?>


        </nav>
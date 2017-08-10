<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>page demo</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
    <br>
    <br>
        <table class="table table-bordered">
            <tr>
                <th>订单号</th>
                <th>创建者用户Id</th>
                <th>创建时间</th>
                <th>服务需求</th>
            </tr>
            <?php foreach ($data as $item): ?>
                <tr>
                    <td><?php echo $item->orderId; ?></td>
                    <td><?php echo $item->createUid; ?></td>
                    <td><?php echo $item->createTime; ?></td>
                    <td><?php echo $item->svrMessage; ?></td>
                </tr>
            <?php endforeach;?>
        </table>
        <div>
            <ul class="pagination">
                <?php foreach ($pageData as $item): ?>
                    <li class="<?php echo $item['class']; ?>">
                        <a href="<?php echo $item['url']; ?>">
                            <?php echo $item['name']; ?>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</body>
</html>


<ul class="nav nav-pills">
    <li><a href="quote.php">Quote</a></li>
    <li><a href="buy.php">Buy</a></li>
    <li><a href="sell.php">Sell</a></li>
    <li><a href="history.php">History</a></li>
    <li><a href="logout.php"><strong>Log Out</strong></a></li>
    <li><a href="changepass.php"><strong>Change Password</strong></a></li>
</ul>

<table class="table table-striped">

    <thead>
        <tr>
            <th>Symbol</th>
            <th>Name</th>
            <th>Shares</th>
            <th>Price</th>
            <th>TOTAL</th>
        </tr>
    </thead>

    <tbody>

    <?php foreach($stocks as $stock): ?>
        <tr>
            <td><?= $stock["symbol"] ?></td>
            <td><?= $stock["name"]?></td>
            <td><?= $stock["shares"]?></td>
             <td><?= $stock["price"]?></td>
             <td><?= $stock["shares"]*$stock["price"]?></td>
        </tr>
    <?php endforeach?>
        <tr>
            <td>CASH</td>
            <td><?=$cash?></td>
        </tr>
    </tbody>

</table>
            

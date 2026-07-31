<h2>Customers</h2>


<table border="1">

<tr>

<th>Code</th>
<th>Name</th>
<th>Phone</th>
<th>State</th>

</tr>


<?php foreach($customers as $customer): ?>


<tr>

<td>
<?= $customer['customer_code']; ?>
</td>

<td>
<?= $customer['first_name']; ?>
<?= $customer['last_name']; ?>
</td>

<td>
<?= $customer['phone']; ?>
</td>

<td>
<?= $customer['state']; ?>
</td>

</tr>


<?php endforeach; ?>


</table>
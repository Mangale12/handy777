{{-- <h1>hello</h1> --}}
<!DOCTYPE html>
<html>
<head>
<style>
table, td, th {
  border: 1px solid black;
}

table {
  border-collapse: collapse;
  width: 50%;
}
</style>
</head>
<body>

<h2>Noor Game "Games And Player Data" </h2>

{{-- <p>Set the width of the table to 50%:</p> --}}
{{-- <p>{{  }}</p> --}}

<table>
  <tr>
    <th>No</th>
    <th>Full Name</th>
    <th>Number</th>
    <th>Email</th>
    <th>Face Book Name</th>
    <th>Balamce Load</th>
    <th>Spiner Key</th>
  </tr>
  @foreach ($load_balance as $form)
  @if($form['totals']['load'] >= 600)

      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $form['full_name'] }}</td>
        <td>{{ $form['number'] }}</td>
        <td>{{ $form['email'] }}</td>
        <td>{{ $form['facebook_name'] }}</td>
        <td>{{ $form['totals']['load'] }}</td>
      </tr>
 @endif

  @endforeach


</table>

</body>
</html>

<div>
    <h1>Select CSV file.</h1>
</div>

<div>
    <form action="/data/import" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="data" accept=".csv">
        <input type="submit">
    </form>
</div>
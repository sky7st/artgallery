<html>
    <head>
        
    </head>
    <body>
        <form action="/artist/insert" method="POST">
            @csrf
            <div class="form-group row">
                <div class="form-group">
                    <label>SSN</label>
                    <input name="ssn" type="text" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input name="name" type="text" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input name="phone" type="text" class="form-control" value="">
                </div>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input name="add" type="text" class="form-control" value="">
            </div><div class="form-group row">
                <div class="form-group">
                    <label>Usual Medium</label>
                    <input name="umedium" type="text" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label>Usual Style</label>
                    <input name="ustyle" type="text" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label>Usual Type</label>
                    <input name="utype" type="text" class="form-control" value="">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group">
                    <label>Sales Last Year</label>
                    <input name="sly" type="text" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label>Sales Year To Date</label>
                    <input name="sytd" type="text" class="form-control" value="">
                </div>
                <div class="col-md-2 form-group">
                    <input type="submit" class="btn btn-success btnModal" value="提交"/>
                </div>
                <div class="col-md-2 form-group">
                    <button type="button" class="btn btn-light btnModal">Cancel</button>
                </div>
            </div>
        </form>
        
    </body>
</html>
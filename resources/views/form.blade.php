<div class="container">
    <div class="row">
        <div class="col-md-3">&nbsp;</div>
        <div class="col-md-6">
            <h2>Weather</h2>
            <from>
                @csrf
                <div class="form-group">
                    <label for="testApi">API key:</label>
                    <input type="text" name="apikey" class="form-control" id="testApi" placeholder="API key"
                           value="">
                </div>
                <div class="form-group">
                    <label for="testCity">City:</label>
                    <div class="input-group mb-3">

                        <input type="text" name="city" class="form-control" id="testCity" placeholder="City"
                               value="">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" id="buttonSuccess"><span aria-hidden="true">&nbsp;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </from>
            <div class="alert alert-warning hidden" role="alert"></div>
            <div class="city-tabs mt-5">
                <ul class="nav nav-tabs"></ul>
                <div class="tabs-inner">
                    <div class="city-inner" id="emptyInner">
                        <div class="inline test-temp"><span class="city-temp"></span>C°</div>
                        <span class="city-clouds"></span>
                        <span class="city-info"></span>
                        <div>country: <span class="city-country"></span></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-3">&nbsp;</div>
    </div>
</div>
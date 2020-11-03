<div class="form-group {{ $errors->has('vehicleId') ? 'has-error' : ''}}">
    <label for="vehicleId" class="control-label">{{ 'Vehicleid' }}</label>
    <input class="form-control" name="vehicleId" type="number" id="vehicleId" value="{{ isset($parking->vehicleId) ? $parking->vehicleId : ''}}" >
    {!! $errors->first('vehicleId', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('lotId') ? 'has-error' : ''}}">
    <label for="lotId" class="control-label">{{ 'Lotid' }}</label>
    <input class="form-control" name="lotId" type="number" id="lotId" value="{{ isset($parking->lotId) ? $parking->lotId : ''}}" >
    {!! $errors->first('lotId', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>

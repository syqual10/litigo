<fieldset>  
    <div class="row">         
        <section class="col-sm-3">
            <label class="label">Unidad Monetaria:</label>
                <select class="form-control select2" id="selectUnidadMonetaria" name="selectUnidadMonetaria" onchange="seleccionUnidadMonetaria(this.value);" style="width:250px">
                <option value="0">Seleccione Unidad Monetaria</option>
                <option value="1">Salarios mínimos</option>
                <option value="2">Pesos</option>
            </select>
        </section>

        <section class="col-sm-3">
            <div id="divPesos" style="display: none;">
                <label class="label">Valor:</label> 
                <input type="text" id="valor" name="valor" class="form-control" placeholder="Valor" onkeyup="format(this)" onchange="format(this)" onkeypress="return justNumbers(event);" onBlur="copiar();">
            </div>

            <div id="divSalariosMinimos" style="display: none;">
                <label class="label">Salarios Mínimos</label>
                <input type="hidden" name="slv" id="slv" value="{{$slv}}">
                <input type="text" id="valorSalarios" name="valorSalarios" class="form-control" placeholder="Salarios Mínimos" onkeyup="format(this)" onchange="format(this)" oninput="salarioAPesos(this);">
            </div>
        </section>
        <div id="divValores" style="display: none;">
            <section class="col-sm-3">                               
                <label class="label">Valor en pesos</label>
                <input type="text" id="valorPesos" name="valorPesos" class="form-control" placeholder="Valor en pesos" readonly> 
            </section>
            <section class="col-sm-1">
                <label class="label">&nbsp;</label>
                <a id="eventUrl" class="btn btn-success btn-xs btn-guardar-cuantia" style="color:#fff; text-decoration:none;" onclick="validarGuardarCuantia();">
                    <i class="fa fa-dollar"></i> Agregar Cuantía
                </a>
            </section>
        </div>
    </div>
</fieldset>
<hr>
<div id="resultadoTablaCuantias"></div>
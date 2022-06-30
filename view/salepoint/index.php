<div class="content-wrapper" style="min-height: 2838.44px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Punto de Venta</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">TPV</a></li>
              <li class="breadcrumb-item"><a href="dashboard">Panel de Control</a></li>
              <li class="breadcrumb-item active">Punto de Venta</li>
            </ol>
          </div><!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title text-right">Venta Actual: $000</h3>          
        </div>
        <div class="card-body">
         <div class="row">
             <div class="col-md-3">
                 <div class="form-group">
                     <label for="cantidad" class="control-label">Cantidad</label>
                     <input type="number" name="cantidad" id="cantidad" class="form-control">
                 </div>
             </div>
             <div class="col-md-6">
             <div class="form-group">
                    <label for="producto" class="control-label">Producto</label>
                    <select name="" id="" class="form-control">
                      <option value="0">Seleccione</option>
                      <?php foreach ($this->products as $product): ?>
                        <option value="<?php echo $product['codigo']; ?>"><?php echo $product['nombre']; ?></option>
                      <?php endforeach; ?>
                    </select>
                 </div>
             </div>
             <div class="col-md-3">
                 <label for="" class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                 <button class="btn btn-success"><i class="fas fa-plus"></i> Agregar</button>
                 <button class="btn btn-info"><i class="fas fa-search"></i> Buscar</button>
             </div>
             
         </div>
         <div class="row">
             <div class="col-md-12">
                 <table class="table">
                     <thead>
                         <tr>
                             <th>Cant.</th>
                             <th>Producto</th>
                             <th>Unitario</th>
                             <th>Total</th>
                             <th></th>
                         </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                 </table>
             </div>
         </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
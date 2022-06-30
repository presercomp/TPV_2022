<div class="content-wrapper" style="min-height: 2838.44px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Nuevo Producto</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">TPV</a></li>
              <li class="breadcrumb-item"><a href="dashboard">Panel de Control</a></li>
              <li class="breadcrumb-item"><a href="products">Administración de Productos</a></li>
              <li class="breadcrumb-item active">Nuevo</li>
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
        </div>
        <div class="card-body">         
            <form action="<?php echo URL.'/product/add';?>" method="POST">
                <div class="form-group">
                    <label for="codigo">Código</label>
                    <input type="number" class="form-control" id="codigo" name="codigo" placeholder="Código">
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                </div>
                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <select class="form-control" id="categoria" name="categoria">
                        <option value="0">-- Seleccione</option>
                    <?php foreach($this->categories as $categoria): ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nombre']; ?></option>
                    <?php endforeach; ?>                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="nombre">Alerta Stock Bajo</label>
                    <input type="number" class="form-control" id="alerta_bajo" name="alerta_bajo">
                </div>
                <div class="form-group">
                    <label for="nombre">Alerta Stock Critico</label>
                    <input type="number" class="form-control" id="alerta_critico" name="alerta_critico">
                </div>
                <button type="button" id="guardar" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
                <script>
                    $("#guardar").on("click", function(){
                        let errores = "";
                        errores += $("#codigo").val().length < 8 ? "El código es obligatorio\n" : "";
                        errores += $("#nombre").val().length ==  0 ? "El nombre es obligatorio\n" : "";
                        errores += $("#categoria").val() ==  0 ? "La categoría es obligatoria\n" : "";
                        errores += $("#alerta_bajo").val().length ==  0 ? "La alerta de stock bajo es obligatoria\n" : "";
                        errores += $("#alerta_critico").val().length ==  0 ? "La alerta de stock critico es obligatoria\n" : "";
                        if(errores.length > 0){
                            alert(errores);
                        }else{
                            $("form").submit();
                        }
                    });
                </script>
            </form>
        </div>        
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
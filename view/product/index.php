<div class="content-wrapper" style="min-height: 2838.44px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Administración de Productos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">TPV</a></li>
              <li class="breadcrumb-item"><a href="dashboard">Panel de Control</a></li>
              <li class="breadcrumb-item active">Administración de Productos</li>
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
          <a href="<?php echo URL . 'product/new'; ?>" class="btn btn-success"><i class="fas fa-plus"></i> Nuevo</a>
        </div>
        <div class="card-body">         
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Alerta Bajo Stock</th>
                                <th>Alerta Stock Crítico</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($this->products as $product): ?>
                                <tr>
                                    <td><?php echo $product['codigo']; ?></td>
                                    <td><?php echo $product['nombre']; ?></td>
                                    <td><?php echo $product['nombre_categoria']; ?></td>
                                    <td><?php echo $product['alerta_bajo']; ?></td>
                                    <td><?php echo $product['alerta_critico']; ?></td>
                                    <td>
                                        <a href="<?php echo URL . 'product/edit/&id=' . $product['codigo']; ?>" class="btn btn-primary">Editar</a>
                                        <button class="btn btn-danger" data-id="<?php echo $product['codigo']; ?>">Eliminar</button>                                        
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <script>                                
                                    $('.btn-danger').click(function(){
                                        var id = $(this).attr('data-id');
                                        var url = '<?php echo URL . 'product/delete/&id='; ?>' + id;
                                        if(confirm('¿Está seguro de eliminar este producto?')){
                                            window.location.href = url;
                                        }
                                    });                                
                            </script>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>        
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
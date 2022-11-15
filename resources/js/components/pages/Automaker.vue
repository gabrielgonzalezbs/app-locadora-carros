<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> Marcas </div>

                    <div class="card-body">

                        <p>
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Filtrar">
                                <i class="bi bi-funnel"></i>
                            </button>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="idFilter" class="form-label">ID</label>
                                        <input type="number" class="form-control" id="idFilter" aria-describedby="idFilter">
                                        <div class="form-text">(Opcional) Você pode filtrar pelo ID das Marcas</div>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="nameFilter" class="form-label">Nome</label>
                                        <input type="text" class="form-control" id="nameFilter">
                                        <div class="form-text">(Opcional) Você pode filtrar pelo Nome das Marcas</div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Pesquisar <i class="bi bi-funnel"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="p-2">
                    <input type="button" value="Create new" @click="newArticle=true,modalForm()" class="btn btn-primary" ></input>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr v-for="article in articles" :key="article.id">
                            <th scope="row">{{article.id}}</th>
                            <td>{{article.name}}</td>
                            <td>{{article.description}}</td>
                            <td>{{article.stock}}</td>
                            <td>
                                <div class="p-1">
                                    <button class="btn btn-warning" @click="newArticle=false,updateArticle(article.id)" data-toggle="modal" data-target="#exampleModalCenter">Update</button>
                                </div>
                                <div class="p-1">
                                    <button class="btn btn-danger" @click="deleteAsk(article.id)">Delete</button>
                                </div>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div> 
            <!-- Modal -->
        <div class="modal" :class="{mostrar: modalStatu}">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">{{modalTitle}}</h4>
                    <button @click="modalStatu=0"  type="button" class="close" data-dismiss="modal">
                    &times;
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="my-4">
                        <label for="nombre">Nombre</label>
                        <input v-model="article.name" type="text" class="form-control" id="nombre" placeholder="Nombre del Articulo">
                        <span v-if="errors.name" class="text-danger">{{errors.name[0]}}</span>
                    </div>
                    <div class="my-4">
                        <label for="descripcion">descripcion</label>
                        <input v-model="article.description" type="text" class="form-control" id="descripcion" placeholder="Descripcion del Articulo">
                        <span v-if="errors.description" class="text-danger">{{errors.description[0]}}</span>
                    </div>
                    <div class="my-4">
                        <label for="stock">stock</label>
                        <input v-model="article.stock" type="number" class="form-control" id="stock" placeholder="Stock del Articulo">
                        <span v-if="errors.stock" class="text-danger">{{errors.stock[0]}}</span>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button  type="button" class="btn btn-secondary" data-dismiss="modal"><!-- @click="cerrarModal();" -->
                        Cancelar
                    </button>
                    <button  @click="saveArticle();" type="button" class="btn btn-success" data-dismiss="modal">
                        Guardar
                    </button>


                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Swal from 'sweetalert2'; 

    export default {
        data(){
            return {
                articles : [],/* all articles */
                article : {
                    name : '',
                    description : '',
                    stock : 1,
                    id : 0,
                }, /* select article */
                newArticle : true,    /* true => create , false => update */         
                modalStatu : 0,
                modalTitle : 'Create new article',
                errors : [],
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            this.getArticles()
        }, 
        methods : {
            async getArticles(){
                const info = await axios.get('/articles');
                this.articles = info.data; 
            },
            
            async deleteArticle(id_article){
                const info = await axios.delete('/articles/'+id_article);
                this.getArticles()                 
                
            },

            async updateArticle(id_article){ 
                const info = await axios.get('/articles/'+id_article);
                // this.article = info.data;  
                this.modalForm(info.data)
            },

            async saveArticle(){
                try {
                    if (this.newArticle) {
                        await axios.post('/articles',this.article);
                    } else {
                        await axios.put('/articles/'+this.article.id, this.article);
                    }
                    this.modalStatu = 0;
                    this.getArticles();
                } catch (error) {
                    console.log(error.response.data);
                    if(error.response.data){
                        this.errors = error.response.data.errors
                    }
                }
            },

            deleteAsk(id_article){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ); 
                        this.deleteArticle(id_article);                        
                    }else{
                        console.log('cancelado la eliminación');
                    }
                })
            },

            modalForm(info={}){
                this.modalStatu = 1;
                this.errors = [];
                if (this.newArticle) {
                    this.article.id = 0;
                    this.article.name = '';
                    this.article.description = '';
                    this.article.stock = 1;
                } else {
                    this.article.id = info.id;
                    this.article.name = info.name;
                    this.article.description = info.description;
                    this.article.stock = info.stock;
                }
            },
            
        }

    }
</script>

<style>
    .mostrar{
      display: list-item;
      opacity: 1;
      background: rgba(75, 56, 143, 0.705);
    }
</style>
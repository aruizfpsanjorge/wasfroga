var usuarios=[];
const url = '../Backend/api/usuarios_1.php';



function obtenerUsuarios(){
    axios({
        method:'GET',
        url:url,
        responseType:'json'}
    
    ).then(res=>{
        console.log(res)
        this.usuarios=res.data;
        llenarTabla();
    }
    ).catch(error=>{console.error(error)});
}

obtenerUsuarios();

function llenarTabla(){
    document.querySelector('#tabla_usuarios tbody').innerHTML='';
    for (let i=0;i<usuarios.length;i++){

        document.querySelector('#tabla_usuarios tbody').innerHTML +=
        `<tr>
            <td>${usuarios[i].id}</td>
            <td>${usuarios[i].Nombre}</td>
            <td>${usuarios[i].Apellido}</td>
            <td>${usuarios[i].FechaNacimiento}</td>
            <td>${usuarios[i].Genero}</td>
            <td><button type="button" onclick="eliminar(${usuarios[i].id})">X</button></td>
        </tr>
        `;
    }

}

function eliminar(id){
    console.log("Eliminar el elemento con indice"+id);
    axios({
        method:'DELETE',
        url:url + `?id=${id}`,
        responseType:'json'}
    
    ).then(res=>{
        console.log(res.data);
        obtenerUsuarios();
        
    }
    ).catch(error=>{console.error(error)});

}

function guardar(){
    let usuario= {
        nombre:document.getElementById('nombre').value,
        apellido:document.getElementById('apellido').value,
        fecha:document.getElementById('Fecha').value,
        genero:document.getElementById('genero').value
    }
    console.log("usuario a guardar",usuario);

    axios({
        method:'POST',
        url:url,
        responseType:'json',
        params:usuario}
    
    ).then(res=>{
        console.log(res.data);
        obtenerUsuarios();
        
    }
    ).catch(error=>{console.error(error)});

}
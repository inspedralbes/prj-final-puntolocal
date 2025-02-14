<template>
    <div>
      <!-- Este componente no se mostrará , es para manejar alertas con SweetAlert2 -->
    </div>
  </template>
  
  <script>
  import Swal from "sweetalert2";
  
  export default {
    name: "Alert",
    props: {
      title: {
        type: String,
        required: true
      },
      text: {
        type: String,
        required: true
      }
    },
    methods: {
      mostrarAlerta() {
        Swal.fire({
          title: this.title,
          text: this.text,
          icon: "info",
          position: "top-end",
          showConfirmButton: true,
          showCancelButton: true,
          confirmButtonText: "Sí",
          cancelButtonText: "No",
          toast: true,
          timer: 5000,
          timerProgressBar: true,
          width: "320px",
        }).then((result) => {
          if (result.isConfirmed) {
            console.log("Usuari va dir SÍ");
            this.$emit('confirmed');  // Emitimos el evento 'confirmed' al componente padre
          } else {
            console.log("Usuari va dir NO");
            this.$emit('canceled');  // Emitimos el evento 'canceled' al componente padre
          }
        });
      }
    },
    mounted() {
      this.mostrarAlerta(); // Llamamos al método al montar el componente
    }
  };
  </script>
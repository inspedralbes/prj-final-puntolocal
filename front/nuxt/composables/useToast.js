import Swal from 'sweetalert2'

export const useToast = () => {
  const toast = (text, icon) => {
    Swal.fire({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        text: text,
        icon: icon
    });
  }

  return {
    toast
  }
}
import { defineStore } from "pinia";

export const useCarritoStore = defineStore("carrito", {
    state: () => ({
        productos: [],
        total_final: 0,
    }),
    actions: {
        inicializaCarrito(carrito, total_final) {
            this.productos = carrito;
            this.total_final = total_final;
        },
        addProducto(item) {
            this.productos.push(item);
        },
        deleteProducto(index) {
            this.productos[index].splice(index, 1);
        },
        updateQuantity(index, newVal) {
            this.productos[index].cantidad = newVal;
            // calcular nuevo subtotal
        },
        calculaTotalFinal() {
            let total = 0;
            this.productos.forEach((elem) => {
                console.log()
                total = total + parseFloat(elem.precio_total);
            });

            this.total_final = total;
        },
    },
});

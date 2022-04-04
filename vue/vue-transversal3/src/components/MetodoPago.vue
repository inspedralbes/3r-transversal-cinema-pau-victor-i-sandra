<template>
  <h2>Pagar</h2>
  <form class="row g-3">
    <div class="col-md-6">
      <label for="titular" class="form-label">Nombre del titular</label>
      <input type="text" class="form-control" id="titular" />
    </div>
    <div class="col-md-6">
      <label for="inputPassword4" class="form-label">Password</label>
      <input type="password" class="form-control" id="inputPassword4" />
    </div>
    <div class="col-6 col-md-4">
      <label for="inputCity" class="form-label">Fecha de caducidad</label>
      <input
        type="text"
        class="form-control"
        id="inputCity"
        placeholder="mm / yy"
      />
    </div>
    <div class="col-6 col-md-2">
      <label for="cvv" class="form-label">CVV</label>
      <input type="text" class="form-control" id="cvv" maxlength="3" />
    </div>
    <div class="col-12">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="condiciones" />
        <label class="form-check-label" for="condiciones"
          >Acepto les condiciones de compra</label
        >
      </div>
    </div>
    <div class="col-12">
      <RouterLink class="btn btn-primary" to="/realitzatpagament"
        >Pagar</RouterLink
      >
      <RouterView />
      <a href="https://www.paypal.com/es/home" class="btn btn-danger paypal"
        >PayPal</a
      >
    </div>
  </form>
</template>

<style>
.paypal {
  margin-left: 10px;
}
</style>

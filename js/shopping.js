$(function () {
  var items = 0

  if ($('#header-cart-detail .product').length != 0) {
    $('#header-cart .fa-shopping-cart .circle').css('display', 'flex')
  }

  if ($('#header-cart-detail .product').length) {
    $('#header-cart').hover(
      function () {
        $('#header-cart-detail').addClass('visible')
        // $('#header-cart-detail').addClass('active')
      },
      function () {
        setTimeout(function () {
          $('#header-cart-detail').removeClass('visible')
        }, 1500)
      },
    )
  }

  $('.buy').on('click', function () {
    // var price = $(this).siblings('.product-price').children('span').html()
    var productID = $(this).data('cart')

    // total = total + parseInt(price)
    // $('#header-cart .total span').html(total)

    $('#header-cart').addClass('active')
    setTimeout(function () {
      $('#header-cart').removeClass('active')
    }, 1500)

    $.ajax({
      url: '../models/ajax/addToCart.php',
      data: { productID: productID },
      method: 'POST',
      beforeSend: function () {
        console.log('beforeSend: Success')
      },
      success: function (data) {
        data = JSON.parse(data)
        if (data['action'] == 'newProduct') {
          console.log('newProduct Script Initiated')

          // Make new product div
          $('#header-cart-detail').append(
            "<div class='product' id='" + data['data'].kosik_id + "'></div>",
          )
          //  Add product image
          $('#header-cart-detail #' + data['data'].kosik_id).append(
            '<img src="img/produkty/' + data['data'].img + '">',
          )
          // Add product name
          $('#header-cart-detail #' + data['data'].kosik_id).append(
            '<div class="product-name">' + data['data'].nazev + '</div>',
          )
          // Add amount
          $('#header-cart-detail #' + data['data'].kosik_id).append(
            '<div class="amount"><i class="fa fa-minus" data-cart="' +
              data['data'].kosik_id +
              '"></i><span>' +
              data['data'].mnozstvi +
              '</span><i class="fa fa-plus" data-cart="' +
              data['data'].kosik_id +
              '"></div>',
          )
          // Add price
          $('#header-cart-detail #' + data['data'].kosik_id).append(
            '<div class="price"><span>' +
              data['data'].cena +
              '</span>,-</div><i class="fa fa-times" data-cart="' +
              data['data'].kosik_id +
              '"></i>',
          )
          //  Make header-cart-detail visible and hoverable
          $('#header-cart-detail').addClass('visible')
          setTimeout(function () {
            $('#header-cart-detail').removeClass('visible')
          }, 1500)

          $('#header-cart').hover(
            function () {
              $('#header-cart-detail').addClass('visible')
            },
            function () {
              setTimeout(function () {
                $('#header-cart-detail').removeClass('visible')
              }, 1500)
            },
          )
          // Change the total price in header-cart
          var total = $('#header-cart .total span').html()
          $('#header-cart .total span').html(
            parseInt(total) + parseInt(data['data'].cena),
          )
          //  Increment the number in the circle next to the cart which shows how many products you have in your cart
          $('#header-cart .fa-shopping-cart .circle')
            .html(
              parseInt($('#header-cart .fa-shopping-cart .circle').html()) + 1,
            )
            .css('display', 'flex')

          // end of new product
        } else {
          console.log('addAmount Script Initiated')
          console.log(data.action)
          $('#header-cart-detail #' + data.cartID + ' .amount span').html(
            parseInt(
              $('#header-cart-detail #' + data.cartID + ' .amount span').html(),
            ) + 1,
          )

          // Change the total price in header-cart
          var total = $('#header-cart .total span').html()

          $('#header-cart .total span').html(
            parseInt(total) + parseInt(data.price),
          )
        }

        //  Change the product price in header-cart-detail acording to the amount
        $('#header-cart-detail #' + data.cartID + ' .price span').html(
          parseInt(
            $('#header-cart-detail #' + data.cartID + ' .price span').html(),
          ) + parseInt(data.price),
        )
      },
    })
  })

  $('#header-cart-detail').on('click', '.fa-minus', function () {
    var id = $(this).data('cart')
    $.ajax({
      url: '../models/ajax/lowerAmount.php',
      data: { ID: id },
      method: 'POST',
      beforeSend: function () {
        console.log('beforeSend: Success')
      },
      success: function (data) {
        console.log('Vypis dat prijatych z php scriptu')
        data = JSON.parse(data)
        console.log(data)
        // console.log(data['mnozstvi'])

        if (data.action == 'lowerAmount') {
          var diff =
            parseInt(
              $(
                '#header-cart-detail #' + data['kosik_id'] + ' .price span',
              ).html(),
            ) /
            parseInt(
              $(
                '#header-cart-detail #' + data['kosik_id'] + ' .amount span',
              ).html(),
            )
          $('#header-cart-detail #' + data['kosik_id'] + ' .amount span').html(
            parseInt(
              $(
                '#header-cart-detail #' + data['kosik_id'] + ' .amount span',
              ).html(),
            ) - 1,
          )

          $('#header-cart-detail #' + data['kosik_id'] + ' .price span').html(
            parseInt(
              $(
                '#header-cart-detail #' + data['kosik_id'] + ' .price span',
              ).html(),
            ) - parseInt(diff),
          )
          var total =
            parseInt($('#header-cart .total span').html()) - parseInt(diff)
          $('#header-cart .total span').html(total)
        } else {
          console.log(data.sql)
          var diff = parseInt(
            $(
              '#header-cart-detail #' + data['kosik_id'] + ' .price span',
            ).html(),
          )
          var total =
            parseInt($('#header-cart .total span').html()) - parseInt(diff)
          $('#header-cart .total span').html(total)
          $('#header-cart-detail #' + data['kosik_id']).remove()
          $('#header-cart .fa-shopping-cart .circle').html(
            parseInt($('#header-cart .fa-shopping-cart .circle').html()) - 1,
          )

          console.log($('#header-cart-detail .product').length)

          if ($('#header-cart-detail .product').length == 0) {
            $('#header-cart').off('mouseenter mouseleave')
            $('#header-cart .fa-shopping-cart .circle').css('display', 'none')
            $('#header-cart-detail').removeClass('visible')
          }
        }
      },
    })
  })

  $('#header-cart-detail').on('click', '.fa-plus', function () {
    var id = $(this).data('cart')
    $.ajax({
      url: '../models/ajax/higherAmount.php',
      data: { ID: id },
      method: 'POST',
      beforeSend: function () {
        console.log('beforeSend: Success')
      },
      success: function (data) {
        console.log('Vypis dat prijatych z php scriptu')
        data = JSON.parse(data)
        console.log(data)

        // Get price of one
        var diff =
          parseInt(
            $(
              '#header-cart-detail #' + data['kosik_id'] + ' .price span',
            ).html(),
          ) /
          parseInt(
            $(
              '#header-cart-detail #' + data['kosik_id'] + ' .amount span',
            ).html(),
          )

        // Increase the price next to product
        $('#header-cart-detail #' + data.kosik_id + ' .price span').html(
          parseInt(
            $('#header-cart-detail #' + data.kosik_id + ' .price span').html(),
          ) + diff,
        )

        //  Increase total price in header-cart
        $('#header-cart .total span').html(
          parseInt($('#header-cart .total span').html()) + diff,
        )

        // Increase amount of product
        $('#header-cart-detail #' + data.kosik_id + ' .amount span').html(
          parseInt(
            $('#header-cart-detail #' + data.kosik_id + ' .amount span').html(),
          ) + 1,
        )
      },
    })
  })

  $('#header-cart-detail').on('click', '.fa-times', function () {
    var id = $(this).data('cart')
    $.ajax({
      url: '../models/ajax/removeFromCart.php',
      data: { ID: id },
      method: 'POST',
      beforeSend: function () {
        console.log('beforeSend: Success')
      },
      success: function (data) {
        console.log('Vypis dat prijatych z php scriptu')
        data = JSON.parse(data)
        console.log(data)

        // Get price of one
        var diff = $(
          '#header-cart-detail #' + data['kosik_id'] + ' .price span',
        ).html()

        //  Decrease total price in header-cart
        $('#header-cart .total span').html(
          parseInt($('#header-cart .total span').html()) - diff,
        )

        //  Delete product from header-cart-detail
        $('#header-cart-detail #' + data.kosik_id).remove()

        //  Decrease amount of products in blue circle by one, and hide it
        $('#header-cart .fa-shopping-cart .circle').html(
          parseInt($('#header-cart .fa-shopping-cart .circle').html()) - 1,
        )

        console.log($('#header-cart-detail .product').length)

        if ($('#header-cart-detail .product').length == 0) {
          $('#header-cart').off('mouseenter mouseleave')
          $('#header-cart .fa-shopping-cart .circle').css('display', 'none')
          $('#header-cart-detail').removeClass('visible')
        }
      },
    })
  })
})

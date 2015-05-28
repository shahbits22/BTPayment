class OrdersController < ApplicationController
	 def new
    @client_token = Braintree::ClientToken.generate
  end

  def create
    nonce = params[:payment_method_nonce]
    puts nonce
   # render action: :new and return unless nonce
    result = Braintree::Transaction.sale(
      amount: "10.00",
      payment_method_nonce: nonce
    )
    @result = result
	@success = result.success?
	@transaction_id = result.transaction.id
    flash[:notice] = "Success! Time, like Nonces, is precious. Use it well." if result.success?
    flash[:alert] = "The nonces have eaten your sale. #{result.transaction.processor_response_text}" unless result.success?
    #redirect_to action: :new
    render 'result'
  end
end

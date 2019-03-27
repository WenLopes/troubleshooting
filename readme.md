Instação:
1) Feito os procedimentos, a aplicação apresentou um erro de chave.
Resolução: php artisan key:generate.

----------------------------------------------------------------------------------------------------------
Desenvolvimento: 
1) No controller "ContractController", a seguinte linha foi adicionada:
- use Model\Customer\CustomerRepository;
Assim, a classe CustomerRepository foi importada para ser utilizada.

2) Na View contract.show ocorreu a seguinte alteração:
@section('body') -> @section('content')
Assim, o include ocorre de forma correta.

3) No Model Costumer > Costumer, método contract(), ocorreu a seguinte alteração:
de:   return $this->hasOne('Model\Contract\ContractItem', 'customer_id', 'customer_id');
para: return $this->hasOne('Model\Contract\Contract', 'customer_id', 'customer_id');
Assim, o model correto pôde ser referenciado.

4) No controler ContractController > Método index(), a passagem dos parâmetros $contract_id e $customer_id foi invertida.
de   : public function index($contract_id,$customer_id, CustomerRepository $customerRepository)
para : public function index($customer_id,$contract_id, CustomerRepository $customerRepository)

5) No model Contract, a seguinte linha foi adicionada:
public $incrementing = false;
Assim, o eloquent entende que a variável $primaryKey não é auto-increment, o que permite que seu field correspondente (nesse 
caso, contract_id) possa ser utilizado nas demais operações.

6) No model Contract, No método scopeFields(), o field 'contract_id' foi adicionado, 
assim, os valores de itens do contrato e id do contrato foram atribuidos ao retorno.

7) A seguinte linha de código foi adicionada na classe App\Http\View\Composers\CurrentDateComposer, método boot().
view()->composer("contract.show","App\Http\View\Composers\CurrentDateComposer");
Assim, o método App\Http\View\Composers\CurrentDateComposer@compose, pode ser acessado na view contracts.show.
Obs: Se necessário, o método poderia ser acessado de qualquer view, bastaria trocar o primeiro parâmetro para " * " .
**************** https://stackoverflow.com/questions/28608527/how-to-pass-data-to-all-views-in-laravel-5

8) No arquivo de rotas, executei a seguinte mudança:
De   : Route::get('/contract/{customer_id}/{contract_id}', ['as' => 'contract.show','uses' => 'ContractController@index'])->defaults('contract_id', 'LOREN');
Para : Route::get('/contract/{customer_id}/{contract_id?}', ['as' => 'contract.show','uses' => 'ContractController@index'])->defaults('contract_id', 'LOREN');
O valor " ? " foi inserido no segundo parâmetro, para que o mesmo não se torne obrigatório na URL.
Feito isso, o próprio método "defaults" se encarrega de redirecionar para a página pertencente ao contract_id = LOREN
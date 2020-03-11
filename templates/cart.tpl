{include file="header.tpl"}
<h1>Корзина</h1>
<div class="row">
    {if !empty($cart_items)}
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Название</th>
                <th scope="col">Цена</th>
                <th scope="col">Количество</th>
                <th scope="col">Сумма</th>
                <th scope="col" width="1" style="white-space: nowrap;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$cart_items item=cart_item}
                {assign var=product value=$cart_item->getProduct()}
                <tr>
                    <td><a href="/product/{$product.id}">{$product.name}</a></td>
                    <td>{$product.price}</td>
                    <td>{$cart_item->getAmount()}</td>
                    <td>{$cart_item->getPrice()}</td>
                    <td>
                        <a href="/cart/delete/{$product.id}" class="badge badge-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        <div class="w-100">
            Товаров: {$cart->getAmount()}
        </div>
        <br>
        <div class="w-100">
            Сумма: {$cart->getPrice()}
        </div>
    {else}
        Корзина пуста
    {/if}
</div>
{include file="bottom.tpl"}
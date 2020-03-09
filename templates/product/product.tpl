{include file="header.tpl"}
<h1>
    {if $product->getId() == 0}
        Добавить товар
    {else}
        Редактировать товар: {$product->getName()}
    {/if}
</h1>
{if !empty($message)}
    {foreach from=$message->getMessage() item=e key=k}
        <div class="alert alert-{$k}" role="alert">
            {$e}
        </div>
    {/foreach}
{/if}
<form action="" method="post">
    <input type="hidden" name="product_id" value="{$product->getId()}">
    <div class="form-group">
        <label for="product_name">Название товара</label>
        <input id="product_name" type="text" name="name" class="form-control" value="{$product->getName()}">
    </div>
    <div class="form-group">
        <label for="product_price">Цена</label>
        <input id="product_price" type="text" name="price" class="form-control" required value="{$product->getPrice()}">
    </div>
    <div class="form-group">
        <label for="product_amount">Количество</label>
        <input id="product_amount" type="number" name="amount" class="form-control" required value="{$product->getAmount()}">
    </div>

    <div class="form-group">
        <label for="product_vendor">Производитель</label>
        <select class="form-control" name="vendor_id" id="product_vendor">
            <option value="0">-</option>
            {foreach from=$vendors item=e}
                <option {if $product->getVendorId() == $e->getId()}selected{/if} value="{$e->getId()}">{$e->getName()}</option>
            {/foreach}
        </select>
    </div>
    <div class="form-group">
        <label for="product_folders">Категории</label>
        <select multiple class="form-control" name="folder_ids[]" id="product_folders">
            <option value="0">-</option>
            {foreach from=$folders item=e}
                <option {if in_array($e->getId(), $product->getFolderIds())}selected{/if} value="{$e->getId()}">{$e->getName()}</option>
            {/foreach}
        </select>
    </div>

    <div class="form-group">
        <label for="product_description">Описание товара</label>
        <textarea id="product_description" name="description" class="form-control" rows="3">{$product->getDescription()}</textarea>
    </div>

    <button type="submit" class="btn btn-primary mb-2">Сохранить</button>
</form>

{include file="bottom.tpl"}
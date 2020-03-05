{include file="header.tpl"}
<div class="row">
    <div class="col-6 mb-4"><a href="/product/edit" class="btn btn-success">Добавить товар ({$products.count})</a></div>
</div>

<nav>
    <ul class="pagination pagination-sm">
        {section start=1 loop=$paginator.pages+1 name="paginator"}
            <li class="page-item {if $smarty.section.paginator.iteration == $paginator.current}active{/if}">
                {if $smarty.section.paginator.iteration == $paginator.current}
                    <span class="page-link">{$smarty.section.paginator.iteration}</span>
                {else}
                    <a class="page-link" href="?page={$smarty.section.paginator.iteration}">{$smarty.section.paginator.iteration}</a>
                {/if}
            </li>
        {/section}
    </ul>
</nav>

<div class="row">
    {foreach from=$products.items item=product}
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"  aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Фото товара</text></svg>
                <div class="card-body">
                    <p class="card-text"><a href="/product/view/{$product.id}">{$product.name}</a></p>
                    <p>
                    <ul>
                        <li>Кол-во товара: {$product.amount}</li>
                        {assign var=product_vendor_id value=$product.vendor_id}
                        <li>Производитель: {$vendors[$product_vendor_id].name}</li>
                        <li>Категории: {foreach from=$product->getFolderIds() item=folder_id name=product_folder_ids}{$folders[$folder_id].name}{if !$smarty.foreach.product_folder_ids.last}, {/if}{foreachelse}&ndash;{/foreach}</li>
                    </ul>
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            {*								<button type="button" class="btn btn-sm btn-outline-secondary">View</button>*}
                            <a href="/product/edit/{$product.id}" class="btn btn-sm btn-outline-secondary">Редактировать</a>
                            <a href="/product/buy/{$product.id}" class="btn btn-sm btn-outline-secondary">Купить</a>
                        </div>
                        <small class="text-muted">{$product.price}</small>
                    </div>
                    <div>
                        <p style="padding: 10px 10px 0 10px; font-size: 0.8em;">{$product.description}</p>
                    </div>
                </div>
            </div>
        </div>
    {/foreach}
</div>

{include file="bottom.tpl"}
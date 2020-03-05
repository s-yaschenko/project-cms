<?php


namespace App\Model;

class Product extends AbstractEntity
{
    /**
     * @var string
     */
    protected $table_name = 'products';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     * @DbColumn()
     */
    protected $name;

    /**
     * @var float
     * @DbColumn()
     */
    protected $price;

    /**
     * @var int
     * @DbColumn()
     */
    protected $amount;

    /**
     * @var string
     * @DbColumn()
     */
    protected $description;

    /**
     * @var int
     * @DbColumn()
     */
    protected $vendor_id;

    /**
     * @var array
     */
    protected $folder_ids;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getVendorId(): int
    {
        return $this->vendor_id;
    }

    /**
     * @param int $vendor_id
     */
    public function setVendorId(int $vendor_id): void
    {
        $this->vendor_id = $vendor_id;
    }

    /**
     * @return array
     */
    public function getFolderIds(): array
    {
        return $this->folder_ids;
    }

    /**
     * @param int $folder_id
     */
    public function addFolderId(int $folder_id)
    {
        $this->folder_ids[] = $folder_id;
    }

    /**
     * @param int $folder_id
     */
    public function removeFolderId(int $folder_id)
    {
        $index = array_search($folder_id, $this->getFolderIds());

        if ($index > -1) {
            unset($this->folder_ids[$index]);
        }
    }

    public function removeAllFolders()
    {
        $this->folder_ids = [];
    }

    /**
     * @param int $folder_id
     * @return bool
     */
    public function isFolderIdExist(int $folder_id): bool
    {
        return in_array($folder_id, $this->getFolderIds());
    }
}
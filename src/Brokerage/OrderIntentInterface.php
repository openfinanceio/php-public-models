<?php
namespace CFX\Brokerage;

interface OrderIntentInterface extends \CFX\JsonApi\ResourceInterface {
    // Getters
    public function getType();
    public function getNumShares();
    public function getPriceHigh();
    public function getPriceLow();
    public function getStatus();
    public function getUser();
    public function getAsset();
    public function getAssetIntent();
    public function getAssetOwner();
    public function getBankAccount();

    // Setters
    public function setType($val);
    public function setNumShares($val);
    public function setPriceHigh($val);
    public function setPriceLow($val);
    public function setStatus($val);
    public function setUser(UserInterface $user=null);
    public function setAsset(\CFX\Exchange\AssetInterface $asset=null);
    public function setAssetIntent(\CFX\Brokerage\AssetIntentInterface $asset=null);
    public function setAssetOwner(LegalEntityInterface $owner = null);
    public function setBankAccount(BankAccountInterface $bankAccount = null);
}



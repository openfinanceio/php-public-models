<?php
namespace CFX\Brokerage;

class AssetIntent extends \CFX\JsonApi\AbstractResource implements AssetIntentInterface {
    protected $resourceType = 'asset-intents';
    protected $attributes = [
        'symbol' => null,
        'name' => null,
        'description' => null,
        'assetType' => null,
        'financeType' => null,
        'exemptionType' => null,
        'edgarNum' => null,
        'cusipNum' => null,
        'sharesOutstanding' => null,
        'offerAmount' => null,
        'dateOpened' => null,
        'dateClosed' => null,
        'initialSharePrice' => null,
        'holdingPeriod' => null,
        'comments' => null,
        'status' => null,
    ];
    protected $relationships = ['asset' => null ];



    // Getters

    public function getSymbol() { return $this->attributes['symbol']; }
    public function getName() { return $this->attributes['name']; }
    public function getDescription() { return $this->attributes['description']; }
    public function getAssetType() { return $this->attributes['assetType']; }
    public function getFinanceType() { return $this->attributes['financeType']; }
    public function getExemptionType() { return $this->attributes['exemptionType']; }
    public function getEdgarNum() { return $this->attributes['edgarNum']; }
    public function getCusipNum() { return $this->attributes['cusipNum']; }
    public function getSharesOutstanding() { return $this->attributes['sharesOutstanding']; }
    public function getOfferAmount() { return $this->attributes['offerAmount']; }
    public function getDateOpened() { return $this->attributes['dateOpened']; }
    public function getDateClosed() { return $this->attributes['dateClosed']; }
    public function getInitialSharePrice() { return $this->attributes['initialSharePrice']; }
    public function getHoldingPeriod() { return $this->attributes['holdingPeriod']; }
    public function getComments() { return $this->attributes['comments']; }
    public function getStatus() { return $this->attributes['status']; }
    public function getAsset() { return $this->relationships['asset']->getData(); }






    // Setters

    public function setSymbol($val=null) {
        $this->validateStatus();
        $this->_setAttribute('symbol', $val);
        return $this;
    }
    public function setName($val=null) {
        $this->_setAttribute('name', $val);

        if (!$this->validateStatus()) return $this;

        if (!$val) {
            $this->setError('name', 'required', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Required Attribute `name` Missing",
                "detail" => "You must provide a name for the asset you're intending to create."
            ]));
        } else {
            $this->clearError('name', 'required');
        }

        return $this;
    }
    public function setDescription($val=null) {
        $this->validateStatus();
        $this->_setAttribute('description', $val);
        return $this;
    }
    public function setAssetType($val=null) {
        $this->validateStatus();
        $this->_setAttribute('assetType', $val);
        return $this;
    }
    public function setFinanceType($val=null) {
        $this->validateStatus();
        $this->_setAttribute('financeType', $val);
        return $this;
    }
    public function setExemptionType($val=null) {
        $this->validateStatus();
        $this->_setAttribute('exemptionType', $val);
        return $this;
    }
    public function setEdgarNum($val=null) {
        $this->validateStatus();
        $this->_setAttribute('edgarNum', $val);
        return $this;
    }
    public function setCusipNum($val=null) {
        $this->validateStatus();
        $this->_setAttribute('cusipNum', $val);
        return $this;
    }
    public function setSharesOutstanding($val=null) {
        if (is_numeric($val)) $val = (int)$val;
        $this->_setAttribute('sharesOutstanding', $val);

        if (!$this->validateStatus()) return $this;

        if ($val && !is_int($val)) {
            $this->setError('sharesOutstanding', 'integer', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Invalid Attribute Value for `sharesOutstanding`",
                "detail" => "`sharesOutstanding` must be an integer or null."
            ]));
        } else {
            $this->clearError('sharesOutstanding', 'integer');
        }

        return $this;
    }
    public function setOfferAmount($val=null) {
        if (is_numeric($val)) $val = (int)$val;
        $this->_setAttribute('offerAmount', $val);

        if (!$this->validateStatus()) return $this;

        if ($val && !is_int($val)) {
            $this->setError('offerAmount', 'integer', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Invalid Attribute Value for `offerAmount`",
                "detail" => "`offerAmount` must be an integer or null."
            ]));
        } else {
            $this->clearError('offerAmount', 'integer');
        }

        return $this;
    }
    public function setDateOpened($val=null) {
        if (is_numeric($val)) $val = (int)$val;
        $this->_setAttribute('dateOpened', $val);

        if (!$this->validateStatus()) return $this;

        if ($val && !is_int($val)) {
            $this->setError('dateOpened', 'integer', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Invalid Attribute Value for `dateOpened`",
                "detail" => "`dateOpened` must be an integer or null."
            ]));
        } else {
            $this->clearError('dateOpened', 'integer');
        }

        return $this;
    }
    public function setDateClosed($val=null) {
        if (is_numeric($val)) $val = (int)$val;
        $this->_setAttribute('dateClosed', $val);

        if (!$this->validateStatus()) return $this;

        if ($val && !is_int($val)) {
            $this->setError('dateClosed', 'integer', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Invalid Attribute Value for `dateClosed`",
                "detail" => "`dateClosed` must be an integer or null."
            ]));
        } else {
            $this->clearError('dateClosed', 'integer');
        }

        return $this;
    }
    public function setInitialSharePrice($val=null) {
        if (is_numeric($val)) $val = (float)$val;
        $this->_setAttribute('initialSharePrice', $val);

        if (!$this->validateStatus()) return $this;

        if ($val && !is_float($val)) {
            $this->setError('initialSharePrice', 'float', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Invalid Attribute Value for `initialSharePrice`",
                "detail" => "`initialSharePrice` must be an float or null."
            ]));
        } else {
            $this->clearError('initialSharePrice', 'float');
        }

        return $this;
    }
    public function setHoldingPeriod($val=null) {
        $this->validateStatus();
        $this->_setAttribute('holdingPeriod', $val);
        return $this;
    }
    public function setComments($val=null) {
        $this->validateStatus();
        $this->_setAttribute('comments', $val);
        return $this;
    }
    public function setStatus($val=null) {
        if ($this->validateReadOnly('status', $val !== $this->getStatus())) {
            $this->_setAttribute('status', $val);
        }
        return $this;
    }


    public function setAsset(\CFX\AssetInterface $val=null) {
        if ($this->validateReadOnly('asset', $val !== $this->getAsset())) {
            $this->_setRelationship('asset', $val);
        }
        return $this;
    }


    public function validateStatus() {
        if ($this->getStatus() !== 'submitted') {
            $this->setError('global', 'status-final', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Updates No Longer Permitted",
                "detail" => "This intent's status is in a final state and you can no longer update it. If you need to update the asset information, create a new intent with the new data."
            ]);
            return false;
        } else {
            $this->clearError('global', 'status-final');
            return true;
        }
    }
}



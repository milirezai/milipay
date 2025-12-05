<?php

namespace MiliPay\Support\Contract;

interface ResourceData
{
    public function buildRequestData():array;
    public function buildVerifyRequestData():array;
    public function buildInquiryRequestData():array;
}

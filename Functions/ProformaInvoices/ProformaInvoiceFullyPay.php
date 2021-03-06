<?php

namespace Fousky\Component\iDoklad\Functions\ProformaInvoices;

use Fousky\Component\iDoklad\Functions\iDokladAbstractFunction;
use Fousky\Component\iDoklad\Model\Void\BooleanModel;

/**
 * @see https://app.idoklad.cz/developer/Help/v2/cs/Api?apiId=PUT-api-v2-ProformaInvoices-id-FullyPay_dateOfPayment_salesPosEquipmentId
 *
 * @author Lukáš Brzák <brzak@fousky.cz>
 */
class ProformaInvoiceFullyPay extends iDokladAbstractFunction
{
    /** @var string $id */
    protected $id;

    /** @var array $urlParts */
    protected $urlParts = [];

    /**
     * @param string         $id
     * @param \DateTime|null $dateOfPayment
     * @param int|null       $salesPosEquipmentId
     */
    public function __construct(string $id, \DateTime $dateOfPayment = null, int $salesPosEquipmentId = null)
    {
        $this->id = $id;

        $parts = [];
        if ($dateOfPayment) {
            $parts['dateOfPayment'] = $dateOfPayment->format('Y-m-d H:i:s');
        }
        if (null !== $salesPosEquipmentId) {
            $parts['salesPosEquipmentId'] = $salesPosEquipmentId;
        }

        $this->urlParts = $parts;
    }

    /**
     * Get iDokladModelInterface class.
     *
     * @see iDokladModelInterface
     *
     * @return string
     */
    public function getModelClass(): string
    {
        return BooleanModel::class;
    }

    /**
     * GET|POST|PUT|DELETE e.g.
     *
     * @see iDoklad::request()
     *
     * @return string
     */
    public function getHttpMethod(): string
    {
        return 'PUT';
    }

    /**
     * Return base URI, e.g. /invoices; /invoice/1/edit and so on.
     *
     * @see iDoklad::call()
     *
     * @return string
     */
    public function getUri(): string
    {
        $uri = sprintf('ProformaInvoices/%s/FullyPay', $this->id);

        if (count($this->urlParts) > 0) {
            $uri .= '?'.http_build_query($this->urlParts);
        }

        return $uri;
    }

    /**
     * Vrátí seznam parametrů, které se předají GuzzleHttp\Client.
     *
     * @see \GuzzleHttp\Client::request()
     * @see iDoklad::call()
     *
     * @return array
     */
    public function getGuzzleOptions(): array
    {
        return [];
    }
}

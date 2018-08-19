<?php
namespace Stratadox\Json\Test\Integration\Asset;

use Stratadox\Json\Json;
use Stratadox\Json\Parser;

class Signer
{
    private $parseJson;
    private $signatureName;

    public function __construct(Parser $jsonParser, string $name)
    {
        $this->parseJson = $jsonParser;
        $this->signatureName = $name;
    }

    public function addSignatureTo(string $input): string
    {
        return (string) $this->sign($this->parseJson->from($input));
    }

    private function sign(Json $input): Json
    {
        return $input->write($this->signatureName, 'Signed', 'by');
    }
}
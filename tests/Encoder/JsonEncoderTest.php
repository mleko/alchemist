<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Test;

use Mleko\Alchemist\Encoder\JsonEncoder;
use PHPUnit\Framework\TestCase;

class JsonEncoderTest extends TestCase
{

    public function testEncode() {
        $encoder = new JsonEncoder();
        $this->assertEquals(
            "{\"array\":[123,\"123\"]}",
            $encoder->encode(["array" => [123, "123"]], "json")
        );
    }

    public function testDecode() {
        $encoder = new JsonEncoder();
        $this->assertEquals(
            ["test" => [42, "ultimate answer"]],
            $encoder->decode("{\"test\":[42,\"ultimate answer\"]}", "json")
        );
    }

    public function testRecoding() {
        $encoder = new JsonEncoder();
        $input = ["some", "data" => ["to", "serialize", 123]];
        $this->assertEquals($input, $encoder->decode($encoder->encode($input, "json"), "json"));
    }

    public function testCanProcess() {
        $encoder = new JsonEncoder();
        $this->assertTrue($encoder->canProcess("json"));
        $this->assertFalse($encoder->canProcess("xml"));
    }
}

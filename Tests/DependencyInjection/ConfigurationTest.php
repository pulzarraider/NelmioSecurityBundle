<?php

namespace Nelmio\SecurityBundle\Tests\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Nelmio\SecurityBundle\DependencyInjection\Configuration;
use Symfony\Component\Yaml\Parser;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testCspWithReportAndEnforceSubtrees()
    {
        $this->processYamlConfiguration(
            "csp:\n".
            "  report:\n".
            "    script-src:\n".
            "      - 'self'\n".
            "  enforce:\n".
            "    script-src:\n".
            "      - 'self'"
        );
    }

    public function testReportUriScalar()
    {
        $this->processYamlConfiguration(
            "csp:\n".
            "  enforce:\n".
            "    report-uri: /csp/report\n"
        );
    }

    public function testReportUriArray()
    {
        $this->processYamlConfiguration(
            "csp:\n".
            "  enforce:\n".
            "    report-uri:\n".
            "      - /csp/report\n"
        );
    }

    public function testReportUriValidWithMultiple()
    {
        $this->processYamlConfiguration(
            "csp:\n".
            "  enforce:\n".
            "    report-uri:\n".
            "      - /csp/report1\n".
            "      - /csp/report2\n"
        );
    }

    public function testCspWithLevel2()
    {
        $this->processYamlConfiguration(
            "csp:\n".
            "  report:\n".
            "    script-src:\n".
            "      - 'self'\n".
            "    upgrade-insecure-requests: false\n".
            "    block-all-mixed-content: true\n"
        );
    }

    public function testBrowserAdaptiveBoolean()
    {
        $this->processYamlConfiguration(
            "csp:\n".
            "  report:\n".
            "    script-src:\n".
            "      - 'self'\n".
            "    browser_adaptive: true\n"
        );
    }

    public function testBrowserAdaptiveArray()
    {
        $this->processYamlConfiguration(
            "csp:\n".
            "  report:\n".
            "    script-src:\n".
            "      - 'self'\n".
            "    browser_adaptive:\n".
            "      enabled: true\n".
            "      parser: service_name"
        );
    }

    private function processYamlConfiguration($config)
    {
        $parser = new Parser();

        return $this->processYaml($parser->parse($config));
    }

    private function processYaml($parsedYaml)
    {
        $processor = new Processor();
        $configDefinition = new Configuration();

        return $processor->processConfiguration($configDefinition, array($parsedYaml));
    }
}

<?php

namespace App;

class DiscordHandler extends \DiscordHandler\DiscordHandler
{
    protected function write(array $record): void
    {
        // We're using embed mode so ignore the parent condition.
        $embed = [
            'embeds' => [
                [
                    'title' => $record['level_name'],
                    'description' => $this->splitMessage($record['message'])[0],
                    'timestamp' => $record['datetime']->format($this->config->getDatetimeFormat()),
                    'color' => $this->levelColors[$record['level']],
                    'fields' => [
                        [
                            'name' => "Context",
                            'value' => json_encode($record['context'])
                        ]
                    ],
                    'footer' => [
                        'text' => $record['formatted']
                    ]
                ]
            ]
        ];

        foreach($this->config->getWebHooks() as $webHook)
        {
            $this->send($webHook,$embed);
        }
    }
}

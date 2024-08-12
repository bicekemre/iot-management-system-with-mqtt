<?php

namespace App\Console\Commands;

use App\Models\Devices;
use App\Models\Notifications;
use App\Models\Property;
use App\Models\Value;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Facades\MQTT;

class MqttListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $mqtt = MQTT::connection();
        $mqtt->subscribe('kadirmercan5/topic', function ($topic, $message) {
            try {
                $json = json_decode($message);

                echo sprintf('Received message on topic [%s]: %s', $topic, json_encode($json, JSON_PRETTY_PRINT));

                $device = Devices::query()->where('uuid', $json->uuid)->firstOrFail();
                foreach ($json as $param => $value) {
                    if ($param !== 'uuid') {
                        try {
                            $property = Property::query()->where('name', $param)->firstOrFail();


                            $val = new Value();
                            $val->device_id = $device->id;
                            $val->property_id = $property->id;
                            $val->value = $value;
                            $val->save();

                            $min = $property->min;
                            $max = $property->max;

                            if ($val->value < $min || $val->value > $max) {
                                $notification = new Notifications();
                                $notification->type = 'device';
                                $notification->notifiable_type = Devices::class;
                                $notification->notifiable_id = $device->id;
                                $notification->save();
                            }

                            echo sprintf('New value saved for property [%s]: %s', $param, $value);

                        } catch (\Exception $e) {
                            echo sprintf('Data could not be saved [%s]: %s', $param, $e->getMessage());

                            Log::error('Data could not be saved', [
                                'topic' => $topic,
                                'message' => $message,
                                'exception' => $e->getMessage()
                            ]);
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error processing MQTT message', [
                    'topic' => $topic,
                    'message' => $message,
                    'exception' => $e->getMessage()
                ]);
            }
        }, 1);

        $mqtt->loop(true);
    }

}

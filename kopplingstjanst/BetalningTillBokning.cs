using System;
using System.Collections.Generic;
using System.Text;
using System.Text.Json;
using System.Net;
using RabbitMQ.Client;
using RabbitMQ.Client.Events;

namespace kopplingstjanst
{
    class BetalningTillBokning
    {
        public BetalningTillBokning(IModel model, string exchange, string apiurl)
        {
            model.ExchangeDeclare(exchange: exchange, type: ExchangeType.Fanout, durable: false, autoDelete: false);

            var queueName = model.QueueDeclare().QueueName;
            model.QueueBind(queue: queueName, exchange: exchange, routingKey: "");

            var consumer = new EventingBasicConsumer(model);
            consumer.Received += (model, ea) =>
            {
                var doc = JsonDocument.Parse(ea.Body);

                var referens = doc.RootElement.GetProperty("referens").GetString();
                var beloppBetalt = doc.RootElement.GetProperty("beloppBetalt").GetInt32();

                using (var client = new WebClient())
                {
                    client.DownloadString($"{apiurl}/bokning/uppdateraBeloppBetalt?bokningsnr={referens}&belopp={beloppBetalt}");
                }
            };

            model.BasicConsume(queue: queueName, autoAck: true, consumer: consumer);
        }
    }
}

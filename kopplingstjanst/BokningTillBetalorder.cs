using System;
using System.Collections.Generic;
using System.Text;
using System.Text.Json;
using System.Net;
using RabbitMQ.Client;
using RabbitMQ.Client.Events;

namespace kopplingstjanst
{
    class BokningTillBetalorder
    {
        public BokningTillBetalorder(IModel model, string exchange, string apiurl)
        {
            model.ExchangeDeclare(exchange: exchange, type: ExchangeType.Fanout, durable: false, autoDelete: false);

            var queueName = model.QueueDeclare().QueueName;
            model.QueueBind(queue: queueName, exchange: exchange, routingKey: "");

            var consumer = new EventingBasicConsumer(model);
            consumer.Received += (model, ea) =>
            {
                var doc = JsonDocument.Parse(ea.Body);

                var bokningsnr = doc.RootElement.GetProperty("bokningsnr").GetInt32();
                var pris = doc.RootElement.GetProperty("pris").GetInt32();
                var beloppBetalt = doc.RootElement.GetProperty("beloppBetalt").GetInt32();
                var kundnr = doc.RootElement.GetProperty("kundnr").GetInt32();

                if (pris != beloppBetalt)
                {
                    using (var client = new WebClient())
                    {
                        client.DownloadString($"{apiurl}/betalorder/skapa?applikation=bokning&referens={bokningsnr}&beskrivning=bokning&belopp={pris - beloppBetalt}&kundnr={kundnr}");
                    }
                }
            };

            model.BasicConsume(queue: queueName, autoAck: true, consumer: consumer);
        }
    }
}

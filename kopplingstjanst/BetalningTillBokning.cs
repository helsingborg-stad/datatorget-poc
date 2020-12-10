using System;
using System.Collections.Generic;
using System.Text;
using System.Text.Json;
using System.Net;
using System.Threading.Tasks;
using System.Net.Http;
using IdentityModel.Client;
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
            consumer.Received += async (model, ea) =>
            {
                var doc = JsonDocument.Parse(ea.Body);

                var referens = doc.RootElement.GetProperty("referens").GetString();
                var beloppBetalt = doc.RootElement.GetProperty("beloppBetalt").GetInt32();

                Console.WriteLine($"BetalningTillBokning referens:{referens} beloppBetalt:{beloppBetalt}");

                await UppdateraBeloppBetalt(apiurl, referens, beloppBetalt);
            };

            model.BasicConsume(queue: queueName, autoAck: true, consumer: consumer);
        }

        private async Task UppdateraBeloppBetalt(string apiurl, string bokningsnr, int belopp)
        {
            var token = await Oauth.RequestClientToken();
            using (var client = new HttpClient())
            {
                client.SetBearerToken(token.AccessToken);
                await client.GetStringAsync($"{apiurl}/bokning/uppdateraBeloppBetalt?bokningsnr={bokningsnr}&belopp={belopp}");
            }
        }
    }
}

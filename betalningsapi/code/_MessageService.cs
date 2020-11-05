using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Text;
using System.Text.Json;
using RabbitMQ.Client;

namespace betalningsapi.code
{
    public static class _MessageService
    {
        public static void Send<T>(string exchange, string routingKey, T obj)
        {
            Send(exchange, routingKey, JsonSerializer.Serialize<T>(obj, new JsonSerializerOptions { PropertyNamingPolicy = JsonNamingPolicy.CamelCase }));
        }

        public static void Send(string exchange, string routingKey, string message)
        {
            if (!_Config.MessageServiceEnabled)
                return;

            var factory = new ConnectionFactory() { HostName = _Config.MessageServiceHost, Port = _Config.MessageServicePort, UserName = _Config.MessageServiceUserName, Password = _Config.MessageServicePassword };
            using (var connection = factory.CreateConnection())
            using (var model = connection.CreateModel())
            {
                model.ExchangeDeclare(exchange: exchange,
                                    type: ExchangeType.Fanout,
                                    durable: false,
                                    autoDelete: false,
                                    arguments: null);

                var body = Encoding.UTF8.GetBytes(message);

                model.BasicPublish(exchange: exchange,
                                    routingKey: "",
                                    basicProperties: null,
                                    body: body);
            }
        }
    }
}

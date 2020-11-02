using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Text;
using RabbitMQ.Client;

namespace bokningsapi.code
{
    public static class _MessageService
    {
        public static void Send(string queue, string routingKey, string message)
        {
            if (!_Config.MessageServiceEnabled)
                return;
                
            var factory = new ConnectionFactory() { HostName = _Config.MessageServiceHost, Port = _Config.MessageServicePort, UserName = _Config.MessageServiceUserName, Password = _Config.MessageServicePassword };
            using(var connection = factory.CreateConnection())
            using(var channel = connection.CreateModel())
            {
                channel.QueueDeclare(queue: queue,
                                    durable: true,
                                    exclusive: false,
                                    autoDelete: false,
                                    arguments: null);

                var body = Encoding.UTF8.GetBytes(message);

                channel.BasicPublish(exchange: "",
                                    routingKey: routingKey,
                                    basicProperties: null,
                                    body: body);
            }
        }
    }
}

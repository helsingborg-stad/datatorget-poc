using System;
using System.Linq;
using System.Collections.Generic;
using System.Collections.Concurrent;
using System.IO;
using System.Threading.Tasks;
using System.Text.Json;
using System.Text.Json.Serialization;
using Microsoft.AspNetCore.Hosting;

namespace betalningsapi.code
{
    public static class _DataStore
    {
        static ConcurrentDictionary<string, Betalorder> Orders;
        static int SenasteOrdernr = 0;

        public static void Init(IWebHostEnvironment env)
        {
            Orders = new ConcurrentDictionary<string, Betalorder>();
        }

        public static void LaggTillNyOrder(Betalorder order)
        {
            var orderNrStr = System.Threading.Interlocked.Increment(ref SenasteOrdernr).ToString();
            order.Betalorderid = orderNrStr + SkapaChecksiffra(orderNrStr);
            var resultat = Orders.TryAdd(order.Betalorderid, order);

            if (!resultat)
            {
                // TODO: Lägg till någon form av retry-policy
                throw new Exception("LaggTillNyOrder: Något gick fel.");
            }
        }

        public static Betalorder SokId(string betalorderid)
        {
            if (Orders.TryGetValue(betalorderid, out var order))
                return order;

            throw new Exception("SokId: Hittade ej ordern.");
        }

        public static Betalorder[] Sok(string applikation, string referens, int kundnr)
        {
            var orders = Orders.Values.ToArray();
            orders = orders.Where(o => string.IsNullOrEmpty(applikation) || o.Applikation == applikation)
                            .Where(o => string.IsNullOrEmpty(referens) || o.Referens == referens)
                            .Where(o => kundnr == 0 || o.Kundnr == kundnr).ToArray();
            return orders;
        }

        private static string SkapaChecksiffra(string str)
        {
            var sum = 0;
            foreach (var ch in str)
                sum += (ch - '0');
            sum = sum % 10;
            sum = 10 - sum;
            sum = sum % 10;
            return sum.ToString();
        }
    }
}

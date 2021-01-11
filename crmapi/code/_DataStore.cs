using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace crmapi.code
{
    public static class _DataStore
    {
        static Dictionary<int, Arende> Arenden = new Dictionary<int, Arende>();
        static int SenasteArendeid = 0;

        public static void SkapaArende(Arende arende)
        {
            Arenden.Add(++SenasteArendeid, arende);
        }

        public static Arende[] ListaArenden()
        {
            return Arenden.Values.ToArray();
        }
    }
}

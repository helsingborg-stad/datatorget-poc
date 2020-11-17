using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace kundapi.code
{
    [MongoDB.Bson.Serialization.Attributes.BsonIgnoreExtraElements]
    public class Kund
    {
        public int Kundnr { get; set; }
        public string Namn { get; set; }
        public string Personnr { get; set; }
        public string Epost { get; set; }
    }
}

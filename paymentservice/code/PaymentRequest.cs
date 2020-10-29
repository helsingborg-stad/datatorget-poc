using System;
using System.Linq;
using System.Collections.Generic;
using System.IO;

namespace paymentservice.code
{
    public class PaymentRequest
    {
        public string PaymentOrderId { get; set; }
        public int Amount { get; set; }
        public int AmountPaid { get; set; }
        public string UserMessage { get; set; }
        public string PaymentApiUri { get; set; }
        public string PaymentUserUri { get; set; }
        public bool IsPaid { get; set; }
        public bool IsCanceled { get; set; }
        public SortedDictionary<string, string> Properties { get; set; }
        public DateTime CreateDate { get; set; }
        public DateTime PaymentDate { get; set; }

        public PaymentRequest()
        {
        }
    }
}
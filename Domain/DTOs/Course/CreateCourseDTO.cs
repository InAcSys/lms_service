using System.Text.Json.Serialization;

namespace LMSService.Domain.DTOs.Course
{
    public class CreateCourseDTO
    {
        [JsonPropertyName("name")]
        public string Name { get; set; } = "";
        [JsonPropertyName("course_code")]
        public string Code { get; set; } = "";
        [JsonPropertyName("start_at")]
        public DateTime? StartAt { get; set; }
        [JsonPropertyName("end_at")]
        public DateTime? EndAt { get; set;}
        [JsonPropertyName("license")]
        public string? License { get; set; } = "private";
        [JsonPropertyName("time_zone")]
        public string? TimeZone { get; set; } = "";
        [JsonPropertyName("is_public")]
        public bool IsPublic { get; set; } = false;
    }
}
